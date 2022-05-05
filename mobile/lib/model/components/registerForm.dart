import 'package:erasmus_helper/model/components/formInput.dart';
import 'package:erasmus_helper/model/login.dart';
import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';
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
  TextEditingController nameController = TextEditingController();

  @override
  void dispose() {
    emailController.dispose();
    passwordController.dispose();
    confirmController.dispose();
    nameController.dispose();
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
            onPressed: () {
              // Validate returns true if the form is valid, or false otherwise.
              if (_formKey.currentState!.validate()) {
                ScaffoldMessenger.of(context).showSnackBar(
                  const SnackBar(content: Text('Creating account')),
                );
                context
                    .read<AuthenticationService>()
                    .signUp(
                      email: emailController.text.trim(),
                      password: passwordController.text.trim(),
                    )
                    .then((value) => Navigator.push(
                        context,
                        MaterialPageRoute(
                            builder: (context) =>
                                const MyHomePage(title: "Homepage"))));
              }
            },
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

    return Form(
        key: _formKey,
        child: Column(children: [
          logo,
          title,
          ...genInputs(context),
          submitButton,
          login
        ]));
  }

  // Generates styled text inputs for the register form
  List<Widget> genInputs(BuildContext context) {
    final emailInput = FormInput(
        keyboard: TextInputType.emailAddress,
        icon: const Icon(Icons.email),
        controller: emailController,
        hintText: "Email address",
        validator: MultiValidator([
          RequiredValidator(errorText: 'Password is required.'),
          EmailValidator(errorText: "Invalid email.")
        ]));

    final passwordValidator = MultiValidator([
      RequiredValidator(errorText: 'Password is required.'),
      MinLengthValidator(8,
          errorText: 'Password must be at least 8 digits long.'),
      PatternValidator(r'(?=.*?[#?!@$%^&*-])',
          errorText: 'Passwords must have at least one special character.')
    ]);

    final passwordInput = FormInput(
      keyboard: TextInputType.text,
      icon: const Icon(Icons.key),
      controller: passwordController,
      hintText: "Password",
      validator: passwordValidator,
      hidable: true,
    );

    final confirmPasswordInput = FormInput(
        keyboard: TextInputType.text,
        icon: const Icon(Icons.key),
        controller: confirmController,
        hintText: "Confirm password",
        validator: passwordValidator,
        hidable: true);

    final nameInput = FormInput(
        keyboard: TextInputType.text,
        icon: const Icon(Icons.account_circle_rounded),
        controller: nameController,
        hintText: "Name",
        validator: MultiValidator([
          RequiredValidator(errorText: "Name is required."),
          MaxLengthValidator(32, errorText: "Max characters reached.")
        ]));

    final facultyInput = Padding(
        padding: const EdgeInsets.only(top: 10),
        child: DropdownButtonFormField<String>(
          icon: const Padding(
            padding: EdgeInsets.only(right: 22),
            child: Icon(Icons.arrow_drop_down),
          ),
          decoration: const InputDecoration(prefixIcon: Icon(Icons.school)),
          hint: const Text('University of origin'),
          items: [
            'University of France',
            'University of Italy',
            'University of Spain',
            'University of Germany'
          ]
              .map(
                  (label) => DropdownMenuItem(child: Text(label), value: label))
              .toList(),
          onChanged: (_) {},
          validator: RequiredValidator(errorText: 'University is required.'),
        ));

    final inputs = [emailInput, passwordInput, confirmPasswordInput, nameInput]
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
