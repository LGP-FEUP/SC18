import 'package:erasmus_helper/services/utils_service.dart';
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

}
