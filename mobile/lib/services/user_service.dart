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

  static DatabaseReference getUserRef() {
    FirebaseAuth auth = FirebaseAuth.instance;
    return FirebaseDatabase.instance
        .ref(collectionName)
        .child(auth.currentUser!.uid);
  }

  static Future<String> getUserName(String uid) async {
    String name = '';

    DatabaseReference user =
        FirebaseDatabase.instance.ref("$collectionName$uid");
    DataSnapshot firstName = await user.child("firstname").get(),
        lastName = await user.child("lastname").get();

    if (firstName.exists) {
      name += firstName.value.toString();
    }

    if (lastName.exists) {
      name += " " + lastName.value.toString();
    }

    return name;
  }
}
