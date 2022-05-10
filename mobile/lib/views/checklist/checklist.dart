import 'package:erasmus_helper/services/user_service.dart';
import 'package:erasmus_helper/views/checklist/task_item.dart';
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
      appBar: AppBar(
        title: const Text("Checklist"),
      ),
      body: Column(
        children: const [TaskItem(), TaskItem()],
      ),
    );
  }
}
