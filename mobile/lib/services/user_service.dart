import 'package:firebase_auth/firebase_auth.dart';
import 'package:firebase_database/firebase_database.dart';

import '../models/user.dart';

class UserService {
  static String collectionName = "users/";

  static void addUser(UserModel user) async {
    DatabaseReference ref =
        FirebaseDatabase.instance.ref(collectionName + user.uid);

    await ref.set(user.getInfo());
  }

  static Future<String> getUserFacultyId() async {
    FirebaseAuth auth = FirebaseAuth.instance;
    final DataSnapshot snap = await FirebaseDatabase.instance
        .ref(collectionName)
        .child(auth.currentUser!.uid).child("faculty_arriving_id")
        .get();

    return snap.value as String;
  }
}
