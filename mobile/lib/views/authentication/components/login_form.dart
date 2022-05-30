import 'package:erasmus_helper/services/authentication_service.dart';
import 'package:erasmus_helper/views/authentication/components/utils.dart';
import 'package:erasmus_helper/views/authentication/register.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'form_input.dart';

class LoginForm extends StatefulWidget {
  const LoginForm({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() => _LoginFormState();
}

class _LoginFormState extends State<LoginForm> {
  final _formKey = GlobalKey<FormState>();
  final emailController = TextEditingController();
  final passwordController = TextEditingController();

  @override
  void dispose() {
    emailController.dispose();
    passwordController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Form(
        key: _formKey,
        child: Column(
          children: <Widget>[
            Utils.genLogo(MediaQuery.of(context).size.height),
            Utils.genTitle("Sign in"),
            ..._genInputs(context),
            Utils.genSubmitButton("Login", onSubmit),
            Utils.genLink("Create an account!", navigateToRegisterPage)
          ],
        ));
  }

  List<Widget> _genInputs(BuildContext context) {
    return [
      EmailInput(controller: emailController),
      PasswordInput(controller: passwordController),
    ]
        .map((e) => Row(children: [
              Expanded(
                  child: Padding(
                      padding:
                          const EdgeInsets.only(top: 10, left: 12, right: 12),
                      child: e))
            ]))
        .toList();
  }

  void onSubmit() {
    // Validate returns true if the form is valid, or false otherwise.
    if (_formKey.currentState!.validate()) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Logging in')),
      );
      context
          .read<AuthenticationService>()
          .signIn(
            email: emailController.text.trim(),
            password: passwordController.text.trim(),
          )
          .then((value) {
        if (value?.compareTo("Signed in") == 0) {
          Utils.navigateToHomePage(context);
        } else {
          ScaffoldMessenger.of(context).showSnackBar(
            SnackBar(
              content: Text(value!),
              backgroundColor: Colors.red,
            ),
          );
        }
      });
    }
  }

  void navigateToRegisterPage() {
    Navigator.push(
        context, MaterialPageRoute(builder: (context) => const RegisterPage()));
  }
}
