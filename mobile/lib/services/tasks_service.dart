import 'package:firebase_database/firebase_database.dart';

class TasksService {
  static String collectionName = "tasks/";

  static void getTasks(String facultyId) async {
    final DataSnapshot snap = await FirebaseDatabase.instance.ref(collectionName)
        .equalTo(facultyId).get();
    print(snap);
  }
}
