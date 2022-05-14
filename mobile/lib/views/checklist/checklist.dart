import 'package:erasmus_helper/services/tasks_service.dart';
import 'package:erasmus_helper/services/faculty_service.dart';
import 'package:erasmus_helper/views/checklist/components/task_tile.dart';
import 'package:flutter/material.dart';

import '../../models/task.dart';

class Checklist extends StatefulWidget {
  const Checklist({Key? key}) : super(key: key);

  @override
  State<StatefulWidget> createState() => _ChecklistState();
}

class _ChecklistState extends State<Checklist> {
  List<TaskModel> tasks = [];

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
        future: Future.wait(// wait for user info
            [
          FacultyService.getUserFacultyId(),
          TasksService.getUserDoneTasks()
        ]),
        builder: (context, response) {
          if (response.connectionState == ConnectionState.done) {
            if (response.data != null) {
              List data = response.data as List;
              String facultyId = data[0].toString();
              List<String> doneTasks = data[1] as List<String>;

              return FutureBuilder(
                  future: TasksService.getTasks(facultyId),
                  builder: (context, response) {
                    if (response.connectionState == ConnectionState.done) {
                      if (response.data != null) {
                        tasks = response.data as List<TaskModel>;
                        _setDoneTasks(doneTasks);
                        return _genPage(tasks);
                      }
                    }
                    return _genPage([]);
                  });
            }
          }
          return _genPage([]);
        });
  }

  Widget _genPage(List<TaskModel> tasks) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Checklist"),
      ),
      body: _buildList(tasks),
    );
  }

  Widget _buildList(List<TaskModel> tasks) {
    final tasksList = tasks.map((e) => TaskTile(task: e)).toList();
    return ListView(
      children: tasksList,
    );
  }  

  void _setDoneTasks(List<String> doneTasks) {
    for (var task in tasks) {
      // mark done tasks
      if (doneTasks.contains(task.uid)) {
        task.done = true;
      }
      for (var step in task.steps) {
        // mark done steps
        if (doneTasks.contains(step.uid)) {
          step.done = true;
        }
      }
    }
  }
}
