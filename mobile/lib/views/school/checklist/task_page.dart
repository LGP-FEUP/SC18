import 'package:erasmus_helper/models/task.dart';
import 'package:erasmus_helper/views/app_topbar.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

import 'components/step_tile.dart';

class TaskPage extends StatefulWidget {
  const TaskPage({Key? key, required this.task}) : super(key: key);

  final TaskModel task;

  @override
  State<TaskPage> createState() => _TaskPageState();
}

class _TaskPageState extends State<TaskPage> {
  @override
  Widget build(BuildContext context) {
    TaskModel task = widget.task;

    return AppTopBar(
        title: task.title,
        activateBackButton: true,
        body: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [_showTaskInfo(task), _showSteps(task.steps)],
        ));
  }

  Widget _showTaskInfo(TaskModel task) {
    return Padding(
      padding: const EdgeInsets.all(15),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            "Due date: ${DateFormat("dd/MM/yyyy").format(task.dueDate)}",
            style: const TextStyle(fontSize: 20),
          ),
          Text(
            task.description,
            style: const TextStyle(fontSize: 15),
          ),
        ],
      ),
    );
  }

  ListView _showSteps(List<StepModel> steps) {
    return ListView.builder(
      scrollDirection: Axis.vertical,
      shrinkWrap: true,
      itemCount: steps.length,
      itemBuilder: (BuildContext context, int index) {
        return StepTile(step: steps[index]);
      },
    );
  }
}
