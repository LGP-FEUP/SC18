import 'package:flutter/material.dart';

class RegisterForm extends StatefulWidget {
  const RegisterForm({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() => _RegisterFormState();
}

class _RegisterFormState extends State<RegisterForm> {
  final _formKey = GlobalKey<FormState>();

  List<Widget> genInputs(BuildContext context) {
    final emailInput = TextFormField(
      keyboardType: TextInputType.emailAddress,
      decoration: InputDecoration(
          icon: const Icon(Icons.email),
          hintText: "Email address",
          contentPadding: const EdgeInsets.all(20),
          border:
              OutlineInputBorder(borderRadius: BorderRadius.circular(50.0))),
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
          border:
              OutlineInputBorder(borderRadius: BorderRadius.circular(50.0))),
      validator: (value) {
        if (value == null || value.isEmpty) {
          return 'Please enter a password';
        }
        return null;
      },
    );

    return [
      Row(children: [
        Expanded(
            child: Padding(
                padding: const EdgeInsets.only(top: 10, left: 10, right: 10),
                child: emailInput))
      ]),
      Row(
        children: [
          Expanded(
              child: Padding(
            padding: const EdgeInsets.only(top: 10, left: 10, right: 10),
            child: passwordInput,
          ))
        ],
      )
    ];
  }

  @override
  Widget build(BuildContext context) {
    const title = Padding(
        padding: EdgeInsets.only(left: 10),
        child: Text(
          'Sign up',
          style: TextStyle(fontWeight: FontWeight.bold, fontSize: 18),
        ));

    return Form(
        key: _formKey,
        child: Column(children: [
          Row(
            children: const [title],
          ),
          ...genInputs(context)
        ]));
  }
}
