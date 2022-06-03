import 'package:erasmus_helper/models/task.dart';
import 'package:erasmus_helper/services/user_service.dart';
import 'package:erasmus_helper/services/utils_service.dart';
import 'package:firebase_database/firebase_database.dart';

class TasksService {
  // static String collectionName = "tasks/";

  static Future<List<TaskModel>> getTasks(String facultyId) async {
    List<TaskModel> tasks = [];
    final DataSnapshot snap = await FirebaseDatabase.instance
        .ref("faculties/$facultyId/tasks/")
        .get();

    if (snap.exists) {
      for (var element in UtilsService.snapToMapOfMap(snap).entries) {
        tasks.add(TaskModel.fromJson(element.key, element.value));
      }
    }
    return tasks;
  }

  static Future<List<String>> getUserDoneTasks() async {
    List<String> doneTasks = [];
    final DataSnapshot snap = await getUserDoneTasksRef().get();

    if (snap.exists) {
      for (var element in UtilsService.snapToMapOfMap(snap).values) {
        doneTasks.add(element.values.first.toString());
      }
    }

    return doneTasks;
  }

  static DatabaseReference getUserDoneTasksRef() {
    return UserService.getUserRef().child("done_tasks");
  }

  static Future<void> deleteUserDoneTask(String id) async {
    final DataSnapshot snap =
        await getUserDoneTasksRef().orderByChild("task_id").equalTo(id).get();

    if (snap.exists) {
      for (var element in snap.children) {
        element.ref.remove();
      }
    }
  }

  // Returns new parentTask state
  static Future<bool> deleteUserDoneStep(
      String id, TaskModel parentTask) async {
    await TasksService.deleteUserDoneTask(parentTask.uid);
    await TasksService.deleteUserDoneTask(id);

    return false;
  }

  // Returns new parentTask state
  static Future<bool> addUserDoneStep(String id, TaskModel parentTask) async {
    List<String> userDoneTasks = await TasksService.getUserDoneTasks();
    var doneSteps = parentTask.steps
        .map((e) => e.uid)
        .where((element) => userDoneTasks.contains(element));

    // Adding step completes the task
    if (doneSteps.length + 1 == parentTask.steps.length) {
      await TasksService.addUserDoneTask(parentTask.uid);
      await TasksService.addUserDoneTask(id);
      return true;
    } else {
      await TasksService.addUserDoneTask(id);
      return false;
    }
  }

  static Future<void> addUserDoneTask(String id) async {
    await getUserDoneTasksRef().push().set({"task_id": id});
  }
}
