import 'package:flutter/material.dart';

import 'package:erasmus_helper/model/components/registerForm.dart';

class RegisterPage extends StatelessWidget {
  const RegisterPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return const SafeArea(
        child: Scaffold(
            body: Center(
                child: SingleChildScrollView(
      child: RegisterForm(),
    ))));
  }
}
