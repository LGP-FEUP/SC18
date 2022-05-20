import 'package:erasmus_helper/models/task.dart';
import 'package:erasmus_helper/services/faculty_service.dart';
import 'package:erasmus_helper/services/tasks_service.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

import 'components/task_tile.dart';


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
    return _buildList(tasks);
  }

  Widget _buildList(List<TaskModel> tasks) {
    List<TaskModel> sortedTasks = _sortTasks(tasks);
    final tasksList = sortedTasks.map((e) => TaskTile(task: e)).toList();

    return ListView(
      children: _genListItems(tasksList),
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

  List<Widget> _genListItems(List<TaskTile> tasksTiles) {
    // List<Widget> before = [_genListTitle("Before Arrival")];
    // List<Widget> during = [_genListTitle("During Arrival")];
    // List<Widget> after = [_genListTitle("After Arrival")];

    List<Widget> before = [];
    List<Widget> during = [];
    List<Widget> after = [];

    for (var t in tasksTiles) {
      var when = t.task.when;
      if (when == "before") {
        before.add(t);
      } else if (when == "during") {
        during.add(t);
      } else {
        after.add(t);
      }
    }

    final emptyFill = _genEmptyFill();

    if (before.isEmpty) {
      before.add(emptyFill);
    }
    if (during.isEmpty) {
      during.add(emptyFill);
    }
    if (after.isEmpty) {
      after.add(emptyFill);
    }

    return [
      Padding(
        padding: const EdgeInsets.all(12),
        child: ExpansionTile(
          title: _genListTitle("Before Arrival"),
          children: before,
        ),
      ),
      Padding(
        padding: const EdgeInsets.all(12),
        child: ExpansionTile(
          title: _genListTitle("During Arrival"),
          children: during,
        ),
      ),
      Padding(
        padding: const EdgeInsets.all(12),
        child: ExpansionTile(
          title: _genListTitle("After Arrival"),
          children: after,
        ),
      ),
    ];
  }

  List<TaskModel> _sortTasks(List<TaskModel> tasks) {
    DateFormat format = DateFormat("dd/MM/yyyy");
    tasks.sort((a, b) {
      DateTime aDate = a.dueDate, bDate = b.dueDate;
      return aDate.compareTo(bDate);
    });

    return tasks;
  }

  Row _genListTitle(String title) {
    return Row(
      children: [
        Padding(
            padding: const EdgeInsets.all(10),
            child: Text(
              title,
              style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 20),
            ))
      ],
    );
  }

  Row _genEmptyFill() {
    return Row(
      children: const [
        Padding(
            padding: EdgeInsets.all(10),
            child: Text(
              "No tasks...",
              style: TextStyle(fontSize: 18, color: Colors.black54),
            ))
      ],
    );
  }
}
