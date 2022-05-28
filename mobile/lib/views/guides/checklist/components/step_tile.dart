import 'package:erasmus_helper/models/task.dart';
import 'package:erasmus_helper/services/tasks_service.dart';
import 'package:flutter/material.dart';

class StepTile extends StatefulWidget {
  final StepModel step;

  const StepTile({Key? key, required this.step}) : super(key: key);

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

  void _changeTaskState(StepModel step) {
    step.done
        ? TasksService.deleteUserDoneTask(step.uid)
        : TasksService.addUserDoneTask(step.uid);
    setState(() {
      step.done = !step.done;
      _icon = step.done ? doneIcon : notDoneIcon;
    });
  }
}
