import 'package:erasmus_helper/models/user.dart';
import 'package:erasmus_helper/services/faculty_service.dart';
import 'package:erasmus_helper/views/authentication/components/utils.dart';
import 'package:erasmus_helper/views/authentication/login.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../../../services/authentication_service.dart';
import 'form_input.dart';

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
  TextEditingController dateController = TextEditingController();

  // ignore: prefer_typing_uninitialized_variables
  var facultyOrigin, facultyArriving;

  @override
  void dispose() {
    emailController.dispose();
    passwordController.dispose();
    confirmController.dispose();
    fNameController.dispose();
    lNameController.dispose();
    dateController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder<Map<String, String>>(
      future: FacultyService.getFacultiesNames(),
      builder: (context, response) {
        if (response.connectionState == ConnectionState.done) {
          if (response.data != null) {
            // arriving faculty is always FEUP
            facultyArriving = response.data!["FEUP"];

            // remove FEUP from origin possibilities
            final erasmusFaculties = response.data;
            erasmusFaculties?.remove("FEUP");

            var faculties = erasmusFaculties?.entries
                .map((e) => DropdownMenuItem<String>(
                    child: Text(e.key), value: e.value))
                .toList();

            return Form(
                key: _formKey,
                child: Column(children: [
                  Utils.genLogo(MediaQuery.of(context).size.height),
                  Utils.genTitle("Sign up"),
                  ..._genInputs(context, faculties!),
                  Utils.genSubmitButton("Sign up", onSubmit),
                  Utils.genLink("Already have an account?", navigateToLoginPage)
                ]));
          }
        }
        return Form(
            key: _formKey,
            child: Column(children: [
              Utils.genLogo(MediaQuery.of(context).size.height),
              Utils.genTitle("Sign in"),
              ..._genInputs(context, []),
              Utils.genSubmitButton("Sign in", onSubmit),
              Utils.genLink(
                  "Already have an account? Sign in!", navigateToLoginPage)
            ]));
      },
    );
  }

  // Generates styled text inputs for the register form
  List<Widget> _genInputs(
      BuildContext context, List<DropdownMenuItem<String>> faculties) {
    final facultyInput = Padding(
        padding: const EdgeInsets.only(top: 10),
        child: DropdownButtonFormField<String>(
          value: facultyOrigin,
          icon: const Padding(
            padding: EdgeInsets.only(right: 22),
            child: Icon(Icons.arrow_drop_down),
          ),
          decoration: const InputDecoration(prefixIcon: Icon(Icons.school)),
          hint: const Text('University of origin'),
          items: faculties,
          onChanged: (selected) {
            facultyOrigin = selected;
          },
          validator: (value) => value == null ? 'Mandatory field.' : null,
        ));

    final inputs = [
      EmailInput(controller: emailController),
      NewPasswordInput(controller: passwordController),
      ConfirmPasswordInput(
          controller: confirmController,
          passwordController: passwordController),
      NameInput(controller: fNameController, name: "First name"),
      NameInput(controller: lNameController, name: "Last name"),
      DateInput(controller: dateController)
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

  void _onSubmit() {
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
          facultyOrigin,
          facultyArriving,
          dateController.text.trim(), []);

      context.read<AuthenticationService>().signUp(user: user).then((value) {
        // On success
        if (value?.compareTo("Signed up") == 0) {
          Utils.navigateToHomePage(context);
        }
      });
    }
  }

  void _navigateToLoginPage() {
    Navigator.push(
        context, MaterialPageRoute(builder: (context) => const LoginPage()));
  }
}
