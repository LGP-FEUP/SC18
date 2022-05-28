import 'package:erasmus_helper/services/utils_service.dart';
import 'package:firebase_database/firebase_database.dart';
import 'package:firebase_storage/firebase_storage.dart';

import '../models/post.dart';

class GroupService {
  static String postsCollection = "posts/";

  static Future<List<PostModel>> getGroupPosts(String groupId) async {
    List<PostModel> posts = [];
    final DataSnapshot snap =
        await FirebaseDatabase.instance.ref("$postsCollection$groupId").get();

    if (snap.exists) {
      for (var element in UtilsService.snapToMapOfMap(snap).entries) {
        posts.add(PostModel.fromJson(element.key, element.value));
      }
    }
    return posts;
  }

  static Query queryGroupPosts(String groupId) {
    return FirebaseDatabase.instance
        .ref("$postsCollection$groupId")
        .orderByChild("time");
  }

  static Future<String> getGroupImage(String groupId) async {
    return await FirebaseStorage.instance
        .ref("groups/$groupId.jpg")
        .getDownloadURL();
  }

  static Future<String> getGroupTitle(String groupId) async {
    DataSnapshot data =
        await FirebaseDatabase.instance.ref("groups/$groupId/title").get();
    return data.value.toString();
  }

  static Future<List<String>> getGroupsWithTag(String tagId) async {
    DataSnapshot data =
        await FirebaseDatabase.instance.ref("interests/$tagId/groups").get();
    if (data.value == null) return [];
    return (data.value as Map).keys.map((e) => e as String).toList();
  }
}
