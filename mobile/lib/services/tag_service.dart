import 'package:firebase_database/firebase_database.dart';
import 'package:erasmus_helper/models/tag.dart';

class TagService {
  static String collectionName = "interests/";

  static Future<List<Tag>> getTags() async {
    DatabaseReference ref = FirebaseDatabase.instance.ref(collectionName);

    final snapshot = await ref.get();
    List<Tag> tags = [];
    if (snapshot.exists) {
      Map<dynamic, dynamic> data = snapshot.value as Map<dynamic, dynamic>;
      data.forEach((key, value) {
        tags.add(Tag.fromJson(value));
      });
    }
    return tags;
  }

  static Future<String> getTagTitle(String tagId) async {
    DataSnapshot data =
        await FirebaseDatabase.instance.ref("$collectionName$tagId/title").get();
    return data.value.toString();
  }
}
