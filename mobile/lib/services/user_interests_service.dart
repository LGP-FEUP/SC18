import 'package:erasmus_helper/models/tag.dart';
import 'package:erasmus_helper/models/user.dart';
import 'package:erasmus_helper/services/user_service.dart';
import 'package:erasmus_helper/services/utils_service.dart';
import 'package:firebase_auth/firebase_auth.dart';
import 'package:firebase_database/firebase_database.dart';

class UserInterestsService {
  static String collectionName = "users_interests/";

  /// Update the link table User/Tags in firebase.
  /// Mainly called when updating the user profile
  static Future<void> updateTagsToUser(List<Tag> tagList, UserModel user) async {
    DatabaseReference ref = FirebaseDatabase.instance.ref(collectionName+
        FirebaseAuth.instance.currentUser!.uid.toString());
    Map<String, bool> mapTagUser = {};
    for (Tag tag in tagList) {
      mapTagUser.addEntries([MapEntry(tag.title, true)]);
    }
    await ref.set(mapTagUser);
  }

  // Return the list of tags of a user. Use an userId instead of an userModel.
  static Future<List<Tag>?> getTagsOfUser(String userId) async {
    DatabaseReference ref= FirebaseDatabase.instance.ref(collectionName+userId);
    DataSnapshot snap = await ref.get();
    List<Tag> tagList = [];
    if (snap.exists) {
      Map<dynamic, dynamic> map = UtilsService.snapToMap(snap);
      map.forEach((key, value) {
        if (value) {
          tagList.add(Tag(key));
        }
      });
      return tagList;
    } else {
      return null;
    }
  }

  // Return the list of users (profiles) with the same interests as some of tagList
  static Future<List<UserModel>?> getUsersWithTags(List<Tag> tagList) async {
    DatabaseReference ref = FirebaseDatabase.instance.ref(collectionName);
    DataSnapshot snap = await ref.get();
    Map<UserModel, int> userList = {};
    if (snap.exists) {
      Map<dynamic, dynamic> map = UtilsService.snapToMap(snap);
      // For each user id (key)
      for (String userId in map.keys) {
        // Doesn't return the current user
        if (userId == FirebaseAuth.instance.currentUser!.uid) {
          continue;
        }
        List<Tag>? tagsUser = await getTagsOfUser(userId);
        // If something want wrong with the previous request
        if (tagsUser == null) {
          continue;
        }
        int nbSameTag = 0;
        // For each required tags
        for (var tag in tagList) {
          // If the user doesn't have one, he is no longer valid (not added to the list of user)
          if (tagsUser.contains(tag)) {
            nbSameTag++;
          }
        }
        if (nbSameTag > 0) {
          UserModel? user = await UserService.getProfileFromId(userId);
          if (user != null) {
            userList.addAll({user: nbSameTag});
          } else {
            continue;
          }
        }
      }
      userList = Map.fromEntries(userList.entries.toList()..sort((e1, e2) => e1.value.compareTo(e2.value)));
      return userList.keys.toList().reversed.toList();
    } else {
      return null;
    }
  }
}