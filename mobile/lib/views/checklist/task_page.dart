import 'package:erasmus_helper/models/task.dart';
import 'package:flutter/material.dart';

class TaskPage extends StatefulWidget {
  const TaskPage({Key? key, required this.task}) : super(key: key);

  final TaskModel task;

  @override
  State<TaskPage> createState() => _TaskPageState();
}

const String date = "27/10/2010";
const String description = "Send email to COOP with required documents";

final List a = [
  {"text": "ID Document", "done": true},
  {"text": "Copy of the fiscal number", "done": true},
  {"text": "Application form", "done": false},
];

class _TaskPageState extends State<TaskPage> {


  @override
  Widget build(BuildContext context) {
    TaskModel task = widget.task;

    return Scaffold(
      appBar: AppBar(
        title: Text(task.title!),
      ),
      body: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Padding(
            padding: const EdgeInsets.all(15),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  "Due Date " + task.dueDate!,
                  style: const TextStyle(fontSize: 20),
                ),
                const SizedBox(
                  height: 10,
                ),
                Text(
                  task.description!,
                  style: const TextStyle(fontSize: 15),
                ),
              ],
            ),
          ),
          ListView.builder(
            scrollDirection: Axis.vertical,
            shrinkWrap: true,
            itemCount: a.length,
            itemBuilder: (BuildContext context, int index) {
              return ListTile(
                title: Text(a[index]['text']),
                trailing: Icon(a[index]["done"]
                    ? Icons.check_circle
                    : Icons.circle_outlined),
                iconColor: Colors.indigo,
              );
            },
          )
        ],
      ),
    );
  }
}
