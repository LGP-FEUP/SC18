
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

    Map<dynamic, dynamic> map = (snap.value as Map<dynamic, dynamic>);
    List<TaskModel> tasks = [];

    for (var element in map.entries) {
      tasks.add(TaskModel.fromJsonMap(element));
    }

    return tasks;
  }
}
