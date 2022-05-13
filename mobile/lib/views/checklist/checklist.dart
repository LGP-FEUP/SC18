import 'package:erasmus_helper/services/tasks_service.dart';
import 'package:erasmus_helper/services/user_service.dart';
import 'package:erasmus_helper/views/checklist/task_page.dart';
import 'package:firebase_database/firebase_database.dart';
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
        future: Future.wait(
            [UserService.getUserFacultyId(), UserService.getUserDoneTasks()]),
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
                        List<TaskModel> tasks =
                            response.data as List<TaskModel>;
                        List<TaskModel> taskList =
                            setDoneTasks(tasks, doneTasks);
                        return _genPage(taskList);
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
      leading: GestureDetector(
        onTap: () {
          //TODO: Does not delete properly as the task_id is nested
          print(task.uid);
          if (!task.done) {
            DatabaseReference ref = UserService.getUserDoneTasksReference();
            DatabaseReference newRef = ref.push();
            newRef.set(
              {"task_id": task.uid},
            );
          } else {
            DatabaseReference ref = UserService.getUserDoneTasksReference();
            ref.child(task.uid).remove();
          }
          setState(() {
            task.done = !task.done;
          });
        },
        child: Icon(
          task.done ? Icons.check_circle : Icons.circle_outlined,
          color: Colors.black,
        ),
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

  List<TaskModel> setDoneTasks(List<TaskModel> tasks, List<String> doneTasks) {
    for (var element in tasks) {
      if (doneTasks.contains(element.uid)) {
        element.done = true;
      }
      for (var step in element.steps) {
        if (doneTasks.contains(step.uid)) {
          step.done = true;
        }
      }
    }

    return tasks;
  }
}
