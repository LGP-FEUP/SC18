import 'package:erasmus_helper/services/tasks_service.dart';
import 'package:erasmus_helper/services/user_service.dart';
import 'package:erasmus_helper/views/checklist/task_item.dart';
import 'package:flutter/material.dart';

import '../../models/task.dart';

class Checklist extends StatefulWidget {
  const Checklist({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() => _ChecklistState();
}

class _ChecklistState extends State<Checklist> {
  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
        future: UserService.getUserFacultyId(),
        builder: (context, response) {
          if (response.connectionState == ConnectionState.done) {
            if (response.data != null) {
              String facultyId = response.data.toString();
              return FutureBuilder(
                  future: TasksService.getTasks(facultyId),
                  builder: (context, response) {
                    if (response.connectionState == ConnectionState.done) {
                      if (response.data != null) {
                        return genPage(genTasks(response.data as List<TaskModel>));
                      }
                    }
                    return genPage([]);
                  });
            }
          }
          return genPage([]);
        });
  }

  List<TaskItem> genTasks(List<TaskModel> tasks) {
    return tasks.map((e) => TaskItem(task: e)).toList();
  }

  Widget genPage(List<TaskItem> tasks) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Checklist"),
      ),
      body: Column(
        children: tasks,
      ),
    );
  }
}
