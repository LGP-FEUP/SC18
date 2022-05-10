import 'package:erasmus_helper/models/task.dart';
import 'package:flutter/material.dart';

class TaskItem extends StatefulWidget {
  final TaskModel task;

  const TaskItem({Key? key, required this.task}) : super(key: key);

  @override
  State<TaskItem> createState() => _TaskItemState();
}

class _TaskItemState extends State<TaskItem> {
  @override
  Widget build(BuildContext context) {
    TaskModel task = widget.task;

    return Padding(
        padding: const EdgeInsets.all(10),
        child: Row(
          children: [
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    task.title!,
                    style: TextStyle(fontSize: 20),
                  ),
                  SizedBox(
                    height: 10,
                  ),
                  Text(
                    "Due date " + task.dueDate!,
                  )
                ],
              ),
            ),
            const Padding(
              padding: EdgeInsets.only(left: 20),
              child: Icon(
                Icons.check_circle,
                size: 35,
              ),
            ),
            const Spacer(),
            const Icon(
              Icons.arrow_forward_ios,
              size: 15,
            )
          ],
        ));
  }
}
