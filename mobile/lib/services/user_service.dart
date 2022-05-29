import 'package:erasmus_helper/services/user_interests_service.dart';
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

  static Future<UserModel?> getProfileFromId(String userId) async {
    DatabaseReference ref = FirebaseDatabase.instance.ref(collectionName + userId);
    DataSnapshot firstname = await ref.child("firstname").get(),
        lastname = await ref.child("lastname").get(),
        interests = await ref.child("interests").get(),
        faculty_origin_id = await ref.child("faculty_origin_id").get(),
        faculty_arriving_id = await ref.child("faculty_arriving_id").get(),
        description = await ref.child("description").get(),
        country_code = await ref.child("country_code").get(),
        phone = await ref.child("phone").get(),
        whatsapp = await ref.child("whatsapp").get(),
        facebook = await ref.child("facebook").get();
    Map<dynamic, dynamic> map = {
      firstname.key: firstname.value,
      lastname.key: lastname.value,
      interests.key: interests.value,
      faculty_origin_id.key: lastname.value,
      faculty_arriving_id.key: lastname.value,
      description.key: description.value,
      country_code.key: country_code.value,
      phone.key: phone.value,
      whatsapp.key: whatsapp.value,
      facebook.key: facebook.value,
    };
    /*
    if (snapshot.exists) {
      return UserModel.fromProfileJson(map);
    } else {
      return null;
    }*/
    return UserModel.fromProfileJson(map);
  }

  static Future<void> updateUserProfile(UserModel profile) async {
    var ref = getUserRef();
    await ref.update(profile.toProfileJson());
    await UserInterestsService.updateTagsToUser(profile.interests, profile);
  }
}
