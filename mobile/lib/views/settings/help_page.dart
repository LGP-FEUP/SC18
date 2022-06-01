import 'package:erasmus_helper/layout.dart';
import 'package:erasmus_helper/views/app_topbar.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

// TODO : replace this page with the good content
class HelpPage extends StatelessWidget {
  const HelpPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return AppLayout(
        body: Column(
          children: const [Text('Help Page'),],
        ),
      activateBackButton: true,
      title: "Help",
    );
  }
}