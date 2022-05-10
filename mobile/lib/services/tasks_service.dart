import 'package:erasmus_helper/models/task.dart';
import 'package:firebase_database/firebase_database.dart';

class TasksService {
  static String collectionName = "tasks/";

  static Future<List<TaskModel>> getTasks(String facultyId) async {
    final DataSnapshot snap = await FirebaseDatabase.instance
        .ref(collectionName)
        .orderByChild("faculty_id")
        .equalTo(facultyId)
        .get();

    final Map<String, Map<String, String>> map =
        (snap.value as Map<dynamic, dynamic>).map((key, value) => MapEntry(
            key.toString(),
            (value as Map<dynamic, dynamic>).map(
                (key, value) => MapEntry(key.toString(), value.toString()))));

    final List<TaskModel> tasks = [];
    map.forEach((key, value) {
      tasks.add(TaskModel(key,
          value["title"], value["description"], value["due_date"], value["faculty_id"]));
    });

    return tasks;
  }
}
