import 'package:erasmus_helper/services/tasks_service.dart';
import 'package:erasmus_helper/services/user_service.dart';
import 'package:erasmus_helper/views/checklist/task_page.dart';
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
    UserService.getUserDoneTasks();

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
                        return _genPage(response.data as List<TaskModel>);
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
    final tasksList = tasks.map((e) => _tile(e)).toList();
    return ListView(
      children: tasksList,
    );
  }

  ListTile _tile(TaskModel task) {
    return ListTile(
      onTap: () => _navigateToTaskPage(task),
      dense: true,
      title: Text(task.title,
          style: const TextStyle(
            fontWeight: FontWeight.w500,
            fontSize: 20,
          )),
      subtitle: Text("Due date: ${task.dueDate}"),
      leading: const Icon(
        Icons.check_circle,
        color: Colors.black,
      ),
      trailing: const Icon(
        Icons.arrow_forward_ios,
        color: Colors.black,
      ),
    );
  }

  void _navigateToTaskPage(TaskModel task) {
    Navigator.push(
        context, MaterialPageRoute(builder: (context) => TaskPage(task: task)));
  }
}
