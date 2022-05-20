import 'package:erasmus_helper/views/app_topbar.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

// TODO : replace this page with the good content
class AccountPage extends StatelessWidget {
  const AccountPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return AppTopBar(
        body: Column(
          children: const [Text('Account Page'),],
        ),
      activateBackButton: true,
      title: "Account Settings",
    );
  }
}