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

    return TaskModel.listFromJson(snap.value as Map<dynamic, dynamic>);
  }
}
