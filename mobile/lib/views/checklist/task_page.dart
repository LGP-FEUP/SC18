import 'package:flutter/material.dart';

class TaskPage extends StatefulWidget {
  const TaskPage({Key? key}) : super(key: key);

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
    return Scaffold(
      appBar: AppBar(
        title: const Text("Task"),
      ),
      body: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Padding(
            padding: const EdgeInsets.all(15),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: const [
                Text(
                  "Due Date " + date,
                  style: TextStyle(fontSize: 20),
                ),
                SizedBox(
                  height: 10,
                ),
                Text(
                  description,
                  style: TextStyle(fontSize: 15),
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
