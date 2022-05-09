import 'package:erasmus_helper/services/authentication_service.dart';
import 'package:erasmus_helper/views/authentication/login.dart';

import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class MyHomePage extends StatefulWidget {
  const MyHomePage({Key? key, required this.title}) : super(key: key);

  final String title;

  @override
  State<MyHomePage> createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(widget.title),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            ElevatedButton(
              onPressed: () {
                context.read<AuthenticationService>().signOut().then((value) =>
                    Navigator.push(
                        context,
                        MaterialPageRoute(
                            builder: (context) => const LoginPage())));
              },
              child: const Text("Sign out"),
            )
          ],
        ),
      ),
    );
  }
}