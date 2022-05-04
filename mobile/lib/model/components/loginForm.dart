import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';

import 'formInput.dart';

class LoginForm extends StatefulWidget {
  const LoginForm({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() => _LoginFormState();
}

class _LoginFormState extends State<LoginForm> {
  final _formKey = GlobalKey<FormState>();

  List<Widget> genInputs(BuildContext context) {
    final emailInput = FormInput(
        keyboard: TextInputType.emailAddress,
        icon: const Icon(Icons.email),
        hintText: "Email address",
        validator: MultiValidator([
          RequiredValidator(errorText: 'Password is required.'),
          EmailValidator(errorText: "Invalid email.")
        ]));

    final passwordInput = FormInput(
      keyboard: TextInputType.text,
      icon: const Icon(Icons.key),
      hintText: "Password",
      validator: MultiValidator([
        RequiredValidator(errorText: 'Password is required.'),
        MinLengthValidator(8,
            errorText: 'Password must be at least 8 digits long.'),
        PatternValidator(r'(?=.*?[#?!@$%^&*-])',
            errorText: 'Passwords must have at least one special character.')
      ]),
      hidable: true,
    );

    return [
      emailInput,
      passwordInput,
    ]
        .map((e) => Row(children: [
              Expanded(
                  child: Padding(
                      padding:
                          const EdgeInsets.only(top: 10, left: 12, right: 12),
                      child: e))
            ]))
        .toList();
    ;
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
                  height: ht * 0.15,
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
              'Sign in',
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
                  const SnackBar(content: Text('Processing Data')),
                );
              }
            },
            child: const Text('Login'),
          ),
        )
      ],
    );

    return Form(
        key: _formKey,
        child: Column(
          children: <Widget>[logo, title, ...genInputs(context), submitButton],
        ));
  }
}
