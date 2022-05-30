import 'package:erasmus_helper/models/task.dart';
import 'package:erasmus_helper/services/faculty_service.dart';
import 'package:erasmus_helper/services/tasks_service.dart';
import 'package:expansion_tile_card/expansion_tile_card.dart';
import 'package:flutter/material.dart';

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
    List<Widget> before = [];
    List<Widget> during = [];
    List<Widget> after = [];

    for (var t in tasksTiles) {
      var when = t.task.when;
      if (when == "before_arrival") {
        before.add(t);
      } else if (when == "during_stay") {
        during.add(t);
      } else if (when == "before_departure") {
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
        child: Column(
          children: [
            _genTileCard("Before Arrival", before),
            const SizedBox(height: 14),
            _genTileCard("During Stay", during),
            const SizedBox(height: 14),
            _genTileCard("Before Departure", after),
            const SizedBox(height: 14),
          ],
        ),
      ),
    ];
  }

  ExpansionTileCard _genTileCard(String title, List<Widget> taskTiles) {
    return (ExpansionTileCard(
      title: _genListTitle(title),
      children: [
        Padding(
          padding: const EdgeInsets.fromLTRB(15, 15, 15, 20),
          child: Column(children: taskTiles),
        ),
      ],
    ));
  }

  List<TaskModel> _sortTasks(List<TaskModel> tasks) {
    tasks.sort((a, b) {
      DateTime aDate = a.dueDate, bDate = b.dueDate;
      return aDate.compareTo(bDate);
    });

    return tasks;
  }

  Text _genListTitle(String title) {
    return Text(
      title,
      style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 18),
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
