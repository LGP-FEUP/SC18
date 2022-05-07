import 'package:erasmus_helper/models/user.dart';
import 'package:erasmus_helper/services/faculty_service.dart';
import 'package:erasmus_helper/views/components/formInput.dart';
import 'package:erasmus_helper/views/login.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../../main.dart';
import '../../services/authentication_service.dart';

class RegisterForm extends StatefulWidget {
  const RegisterForm({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() => _RegisterFormState();
}

class _RegisterFormState extends State<RegisterForm> {
  final _formKey = GlobalKey<FormState>();
  TextEditingController emailController = TextEditingController();
  TextEditingController passwordController = TextEditingController();
  TextEditingController confirmController = TextEditingController();
  TextEditingController fNameController = TextEditingController();
  TextEditingController lNameController = TextEditingController();
  var faculty;

  void onSubmit() {
    // if form is valid
    if (_formKey.currentState!.validate()) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Creating account')),
      );

      UserModel user = UserModel(
          emailController.text.trim(),
          passwordController.text.trim(),
          fNameController.text.trim(),
          lNameController.text.trim(),
          faculty);

      context.read<AuthenticationService>().signUp(user: user).then((value) =>
          Navigator.push(
              context,
              MaterialPageRoute(
                  builder: (context) => const MyHomePage(title: "Homepage"))));
    }
  }

  @override
  void dispose() {
    emailController.dispose();
    passwordController.dispose();
    confirmController.dispose();
    fNameController.dispose();
    lNameController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    var ht = MediaQuery.of(context).size.height;

    final logo = Row(
      children: [
        Expanded(
            child: Padding(
                padding: const EdgeInsets.only(bottom: 20),
                child: Container(
                  height: ht * 0.14,
                  decoration: const BoxDecoration(
                      image: DecorationImage(
                          image: AssetImage("assets/logo.png"))),
                ))),
      ],
    );

    final title = Row(
      children: const [
        Padding(
            padding: EdgeInsets.only(left: 10),
            child: Text(
              'Sign up',
              style: TextStyle(fontWeight: FontWeight.bold, fontSize: 24),
            ))
      ],
    );

    final submitButton = Row(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Padding(
          padding: const EdgeInsets.only(top: 10),
          child: ElevatedButton(
            onPressed: onSubmit,
            child: const Text('Create account'),
          ),
        )
      ],
    );

    final login = TextButton(
        child: const Text(
          'Already have an account?',
          style: TextStyle(color: Colors.grey, fontSize: 14),
        ),
        onPressed: () {
          Navigator.push(context,
              MaterialPageRoute(builder: (context) => const LoginPage()));
        });

    return FutureBuilder<Map<String, String>>(
      future: FacultyService.getFacultiesNames(),
      builder: (context, response) {
        if (response.connectionState == ConnectionState.done) {
          if (response.data != null) {
            var faculties = response.data?.entries
                .map((e) => DropdownMenuItem<String>(
                    child: Text(e.value), value: e.key))
                .toList();

            return Form(
                key: _formKey,
                child: Column(children: [
                  logo,
                  title,
                  ...genInputs(context, faculties!),
                  submitButton,
                  login
                ]));
          }
        }
        return Form(
            key: _formKey,
            child: Column(children: [
              logo,
              title,
              ...genInputs(context, []),
              submitButton,
              login
            ]));
      },
    );
  }

  // Generates styled text inputs for the register form
  List<Widget> genInputs(
      BuildContext context, List<DropdownMenuItem<String>> faculties) {
    final emailInput = EmailInput(controller: emailController);
    final passwordInput = PasswordInput(controller: passwordController);
    final confirmPasswordInput = ConfirmPasswordInput(
        controller: confirmController, passwordController: passwordController);
    final fNameInput =
        NameInput(controller: fNameController, name: "First name");
    final lNameInput =
        NameInput(controller: lNameController, name: "Last name");

    final facultyInput = Padding(
        padding: const EdgeInsets.only(top: 10),
        child: DropdownButtonFormField<String>(
          value: faculty,
          icon: const Padding(
            padding: EdgeInsets.only(right: 22),
            child: Icon(Icons.arrow_drop_down),
          ),
          decoration: const InputDecoration(prefixIcon: Icon(Icons.school)),
          hint: const Text('University of origin'),
          items: faculties,
          onChanged: (selected) {
            faculty = selected;
          },
          validator: (value) => value == null ? 'Mandatory field.' : null,
        ));

    final inputs = [
      emailInput,
      passwordInput,
      confirmPasswordInput,
      fNameInput,
      lNameInput
    ]
        .map((e) => Row(children: [
              Expanded(
                  child: Padding(
                      padding:
                          const EdgeInsets.only(top: 10, left: 12, right: 12),
                      child: e))
            ]))
        .toList();

    return List<Widget>.from(inputs) + [facultyInput];
  }
}
