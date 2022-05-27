import 'package:firebase_database/firebase_database.dart';
import 'package:firebase_storage/firebase_storage.dart';

class GroupService {
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
