import 'package:flutter/material.dart';

import '../../homepage.dart';

class Utils {
  static Row genLogo(double ht) {
    return Row(
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
  }

  static Row genSubmitButton(String text, void Function()? onSubmit) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Padding(
          padding: const EdgeInsets.only(top: 10),
          child: ElevatedButton(
            onPressed: onSubmit,
            child: Text(text),
          ),
        )
      ],
    );
  }

  static TextButton genLink(String text, void Function()? onSubmit) {
    return TextButton(
        child: Text(
          text,
          style: const TextStyle(color: Colors.grey, fontSize: 14),
        ),
        onPressed: onSubmit);
  }

  static Row genTitle(String title) {
    return Row(
      children: [
        Padding(
            padding: const EdgeInsets.only(left: 10),
            child: Text(
              title,
              style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 24),
            ))
      ],
    );
  }

  static void navigateToHomePage(BuildContext context) {
    Navigator.push(
        context,
        MaterialPageRoute(
            builder: (context) => const HomePage(title: "Homepage")));
  }
}
