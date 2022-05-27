import 'package:erasmus_helper/services/utils_service.dart';
import 'package:firebase_database/firebase_database.dart';

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
}