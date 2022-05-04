import 'package:flutter/material.dart';

class LoginForm extends StatefulWidget {
  const LoginForm({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() => _LoginFormState();
}

class _LoginFormState extends State<LoginForm> {
  final _formKey = GlobalKey<FormState>();

  List<Widget> genInputs(BuildContext context) {
    final emailInput = TextFormField(
          keyboardType: TextInputType.emailAddress,
          decoration: InputDecoration(
              icon: const Icon(Icons.email),
              hintText: "Email address",
              contentPadding: const EdgeInsets.all(20),
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(50.0)
                )
              ),
          validator: (value) {
            if (value == null || value.isEmpty) {
              return 'Please enter an email';
            }
            return null;
          },
        );

    final passwordInput = TextFormField(
          keyboardType: TextInputType.emailAddress,
          decoration: InputDecoration(
              icon: const Icon(Icons.key),
              hintText: "Password",
              contentPadding: const EdgeInsets.all(20),
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(50.0)
                )
              ),
          validator: (value) {
            if (value == null || value.isEmpty) {
              return 'Please enter a password';
            }
            return null;
          },
        );
    
    return [
      Padding(
        padding: const EdgeInsets.only(bottom: 5, left: 20, right: 20, top: 20),
        child: emailInput
      ),
      Padding(
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 0),
        child: passwordInput
      ),
    ];
  }

  @override
  Widget build(BuildContext context) {
    var ht = MediaQuery.of(context).size.height;
    return Form(
        key: _formKey,
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          crossAxisAlignment: CrossAxisAlignment.center,
          children: <Widget>[
            Row(
              children: <Widget>[
                Expanded(
                    child: Container(
                  height: ht * 0.2,
                  decoration: const BoxDecoration(
                      image: DecorationImage(
                          image: AssetImage("assets/logo.png"))),
                )),
              ],
            ),
            ...genInputs(context)
          ],
        ));
  }
}
