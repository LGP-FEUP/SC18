import 'package:erasmus_helper/services/user_service.dart';
import 'package:flutter/material.dart';

class Checklist extends StatefulWidget {
  const Checklist({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() => _ChecklistState();
}

class _ChecklistState extends State<Checklist> {
  @override
  Widget build(BuildContext context) {
    UserService.getUserFacultyId();
    return Scaffold(
      body: Container(),
    );
  }

}