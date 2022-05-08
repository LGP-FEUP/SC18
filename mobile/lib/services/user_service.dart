import 'package:firebase_database/firebase_database.dart';

import '../models/user.dart';

class UserService {
  static String collectionName = "users/";

  static void addUser(UserModel user) async {
    DatabaseReference ref = FirebaseDatabase.instance.ref("users/" + user.uid);

    await ref.set(user.getInfo());
  }
}
