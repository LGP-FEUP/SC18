import 'package:erasmus_helper/models/task.dart';
import 'package:erasmus_helper/services/tasks_service.dart';
import 'package:flutter/material.dart';

class StepTile extends StatefulWidget {
  final StepModel step;
  final TaskModel parentTask;
  final Function(bool) updateCallback;

  const StepTile(
      {Key? key,
      required this.step,
      required this.parentTask,
      required this.updateCallback})
      : super(key: key);

  @override
  State<StatefulWidget> createState() => _StepTileState();
}

class _StepTileState extends State<StepTile> {
  late Icon _icon;
  final doneIcon = const Icon(Icons.check_circle, color: Color(0xFF0038FF)),
      notDoneIcon = const Icon(Icons.circle_outlined, color: Colors.black);

  @override
  Widget build(BuildContext context) {
    StepModel step = widget.step;
    _icon = step.done ? doneIcon : notDoneIcon;
    return ListTile(
      title: Text(step.title),
      trailing: GestureDetector(
        onTap: () => _changeTaskState(step),
        child: _icon,
      ),
    );
  }

  Future<void> _changeTaskState(StepModel step) async {
    bool newTaskState = step.done
        ? await TasksService.deleteUserDoneStep(
            widget.step.uid, widget.parentTask)
        : await TasksService.addUserDoneStep(
            widget.step.uid, widget.parentTask);
    setState(() {
      step.done = !step.done;
      _icon = step.done ? doneIcon : notDoneIcon;
    });
    widget.updateCallback(newTaskState);
  }
}
