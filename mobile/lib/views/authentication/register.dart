import 'package:flutter/material.dart';

import 'components/register_form.dart';

class RegisterPage extends StatelessWidget {
  const RegisterPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return const Scaffold(
        body: SafeArea(
            child: Center(
                child: SingleChildScrollView(
      child: RegisterForm(),
    ))));
  }
}
