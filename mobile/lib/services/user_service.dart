import 'package:firebase_auth/firebase_auth.dart';
import 'package:firebase_database/firebase_database.dart';

import '../models/user.dart';

class UserService {
  static String collectionName = "users/";

  static void addUser(UserModel user) async {
    DatabaseReference ref = FirebaseDatabase.instance.ref("users/" + user.uid);

    await ref.set(user.toJson());
  }

  Future<UserModel?> getUserProfile() async {
    var user = FirebaseAuth.instance.currentUser;
    DatabaseReference ref = FirebaseDatabase.instance.ref();
    final snapshot = await ref.child("users/${user!.uid}").get();
    print(snapshot.value);
    if (snapshot.exists) {
      return UserModel.fromJson(snapshot.value as Map<dynamic, dynamic>);
    } else {
      return null;
    }
  }
}
