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

  static Future<List<String>> getInterestUIDs() async {
    DatabaseReference userRef = UserService.getUserRef();
    DataSnapshot data = await userRef.child("interests").get();

    return (data.value as Map).keys.map((e) => e as String).toList();
  }

  Future<UserModel?> getUserProfile() async {
    final snapshot = await getUserRef().get();
    if (snapshot.exists) {
      return UserModel.fromProfileJson(snapshot.value as Map<dynamic, dynamic>);
    } else {
      return null;
    }
  }

  static Future<void> updateUserProfile(UserModel profile) async {
    var ref = getUserRef();
    await ref.update(profile.toProfileJson());
  }

  static Future<List<UserModel>> getUsersWithSameInterests() async {
    //TODO: fetch Users with same interests
    final snapshot = await getUserRef().get();
    if (snapshot.exists) {
      UserModel user =
          UserModel.fromProfileJson(snapshot.value as Map<dynamic, dynamic>);
      return [user, user, user];
    } else {
      return [];
    }
  }
}
