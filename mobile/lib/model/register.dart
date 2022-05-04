import 'package:flutter/material.dart';

import 'package:erasmus_helper/model/components/registerForm.dart';

class RegisterPage extends StatelessWidget {
  const RegisterPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    var ht = MediaQuery.of(context).size.height;

    return SafeArea(
        child: Scaffold(
            body: ListView(children: [
      Row(
        children: [
          Expanded(
              child: Padding(
                  padding: EdgeInsets.all(10),
                  child: Container(
                    height: ht * 0.14,
                    decoration: const BoxDecoration(
                        image: DecorationImage(
                            image: AssetImage("assets/logo.png"))),
                  ))),
        ],
      ),
      const RegisterForm()
    ])));
  }
}
