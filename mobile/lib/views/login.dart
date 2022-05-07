import 'package:flutter/material.dart';

import 'package:erasmus_helper/views/components/login_form.dart';

class LoginPage extends StatelessWidget {
  const LoginPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return const SafeArea(
        child: Scaffold(
            body: Center(
                child: SingleChildScrollView(
      child: LoginForm(),
    ))));
  }
}
