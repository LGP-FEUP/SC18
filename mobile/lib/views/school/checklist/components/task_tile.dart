import 'package:erasmus_helper/models/task.dart';
import 'package:erasmus_helper/services/tasks_service.dart';
import 'package:erasmus_helper/views/school/checklist/task_page.dart';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';


class TaskTile extends StatefulWidget {
  final TaskModel task;

  const TaskTile({Key? key, required this.task}) : super(key: key);

  @override
  State<StatefulWidget> createState() => _TaskTileState();
}

class _TaskTileState extends State<TaskTile> {
  late Icon _icon;
  final doneIcon = const Icon(Icons.check_circle, color: Colors.black),
      notDoneIcon = const Icon(Icons.circle_outlined, color: Colors.black);

  @override
  Widget build(BuildContext context) {
    TaskModel task = widget.task;
    _icon = task.done ? doneIcon : notDoneIcon;
    return ListTile(
      onTap: () => _navigateToTaskPage(task),
      dense: true,
      title: Text(task.title,
          style: const TextStyle(
            fontWeight: FontWeight.w500,
            fontSize: 20,
          )),
      subtitle: Text("Due date: ${DateFormat("dd/MM/yyyy").format(task.dueDate)}",
          style: const TextStyle(fontSize: 16)),
      leading: GestureDetector(
        onTap: () => _changeTaskState(task),
        child: _icon,
      ),
      trailing: const Icon(
        Icons.arrow_forward_ios,
        color: Colors.black,
      ),
    );
  }

  void _changeTaskState(TaskModel task) {
    task.done
        ? TasksService.deleteUserDoneTask(task.uid)
        : TasksService.addUserDoneTask(task.uid);
    setState(() {
      task.done = !task.done;
      _icon = task.done ? doneIcon : notDoneIcon;
    });
  }

  void _navigateToTaskPage(TaskModel task) {
    Navigator.push(
        context, MaterialPageRoute(builder: (context) => TaskPage(task: task)));
  }
}
