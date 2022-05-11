import 'package:firebase_auth/firebase_auth.dart';
import 'package:firebase_database/firebase_database.dart';

import '../models/user.dart';

class UserService {
  static String collectionName = "users/";

  static void addUser(UserModel user) async {
    DatabaseReference ref =
        FirebaseDatabase.instance.ref(collectionName + user.uid);

    await ref.set(user.toJson());
  }

  static Future<String> getUserFacultyId() async {
    FirebaseAuth auth = FirebaseAuth.instance;
    final DataSnapshot snap = await FirebaseDatabase.instance
        .ref(collectionName)
        .child(auth.currentUser!.uid)
        .child("faculty_arriving_id")
        .get();

    return snap.value as String;
  }

  static Future<List<String>> getUserDoneTasks() async {
    FirebaseAuth auth = FirebaseAuth.instance;
    final DataSnapshot snap = await FirebaseDatabase.instance
        .ref(collectionName)
        .child(auth.currentUser!.uid)
        .child("done_tasks")
        .get();

    List<String> doneTasks = [];

    if (snap.value != null) {
      final Map<String, Map<dynamic, dynamic>> map =
      (snap.value as Map<dynamic, dynamic>).map((key, value) =>
          MapEntry(key.toString(), (value as Map<dynamic, dynamic>)));

      for (var element in map.values) {
        doneTasks.add(element.values.toString());
      }
    }

    return doneTasks;
  }
}
