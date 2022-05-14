import 'package:erasmus_helper/models/task.dart';
import 'package:erasmus_helper/services/user_service.dart';
import 'package:erasmus_helper/services/utils_service.dart';
import 'package:firebase_auth/firebase_auth.dart';
import 'package:firebase_database/firebase_database.dart';

class TasksService {
  static String collectionName = "tasks/";

  static Future<List<TaskModel>> getTasks(String facultyId) async {
    List<TaskModel> tasks = [];
    final DataSnapshot snap = await FirebaseDatabase.instance
        .ref(collectionName)
        .orderByChild("faculty_id")
        .equalTo(facultyId)
        .get();

    if (snap.value != null) {
      for (var element in UtilsService.snapToMapOfMap(snap).entries) {
        tasks.add(TaskModel.fromJson(element.key, element.value));
      }
    }

    return tasks;
  }

  static Future<List<String>> getUserDoneTasks() async {
    List<String> doneTasks = [];
    final DataSnapshot snap = await getUserDoneTasksRef().get();

    if (snap.value != null) {
      for (var element in UtilsService.snapToMapOfMap(snap).values) {
        doneTasks.add(element.values.first);
      }
    }

    return doneTasks;
  }

  static DatabaseReference getUserDoneTasksRef() {
    return UserService.getUserRef().child("done_tasks");
  }
}
