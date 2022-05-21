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

  Future<UserModel?> getUserProfile() async {
    final snapshot = await getUserRef().get();
    print(snapshot.value);
    if (snapshot.exists) {
      return UserModel.fromJson(snapshot.value as Map<dynamic, dynamic>);
    } else {
      return null;
    }
  }

  static void updateUserProfile(UserModel profile) async {
    var ref = getUserRef();
    await ref.update(profile.toProfileJson());
  }
}
