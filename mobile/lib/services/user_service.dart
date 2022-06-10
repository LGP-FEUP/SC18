import 'package:erasmus_helper/services/user_interests_service.dart';
import 'package:erasmus_helper/services/utils_service.dart';
import 'package:firebase_auth/firebase_auth.dart';
import 'package:firebase_database/firebase_database.dart';
import 'package:firebase_storage/firebase_storage.dart';

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

  static Future<UserModel?> getUserProfile() async {
    final snapshot = await getUserRef().get();
    FirebaseStorage storage =
        FirebaseStorage.instanceFor(bucket: "gs://erasmus-helper.appspot.com");
    FirebaseAuth auth = FirebaseAuth.instance;
    if (snapshot.exists) {
      UserModel userModel =
          UserModel.fromProfileJson(snapshot.value as Map<dynamic, dynamic>);
      final storageRef =
          storage.ref().child('avatars/${auth.currentUser!.uid}.jpg');
      // print(storageRef);
      try {
        userModel.avatar = await storageRef.getDownloadURL();
      } on FirebaseException {
        // Caught an exception from Firebase.
        final storageRef = storage.ref().child('avatars/default.png');
        userModel.avatar = await storageRef.getDownloadURL();
        // print("Failed with error '${e.code}': ${e.message}");
      }
      return userModel;
    } else {
      return null;
    }
  }

  static Future<UserModel?> getProfileFromId(String userId) async {
    DatabaseReference ref =
        FirebaseDatabase.instance.ref(collectionName + userId);
    FirebaseStorage storage =
        FirebaseStorage.instanceFor(bucket: "gs://erasmus-helper.appspot.com");
    Map<String, dynamic> map = await UtilsService.mapOfRefChildren(ref, [
      "firstname",
      "lastname",
      "interests",
      "faculty_origin_id",
      "faculty_arriving_id",
      "description",
      "country_code",
      "phone",
      "whatsapp",
      "facebook"
    ]);
    UserModel userModel = UserModel.fromProfileJson(map);
    try {
      final storageRef = storage.ref().child('avatars/$userId.jpg');
      userModel.avatar = await storageRef.getDownloadURL();
    } on FirebaseException {
      // Caught an exception from Firebase.
      // print("Failed with error '${e.code}': ${e.message}");
      final storageRef = storage.ref().child('avatars/default.png');
      userModel.avatar = await storageRef.getDownloadURL();
    }
    return userModel;
  }

  static Future<void> updateUserProfile(UserModel profile) async {
    var ref = getUserRef();
    await ref.update(profile.toProfileJson());
    await UserInterestsService.updateTagsToUser(profile.interests, profile);
  }
}
