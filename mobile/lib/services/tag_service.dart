import 'package:erasmus_helper/models/tag.dart';
import 'package:firebase_database/firebase_database.dart';

class TagService {
  static String collectionName = "interests/";

  static Future<List<Tag>> getTags() async {
    DatabaseReference ref = FirebaseDatabase.instance.ref(collectionName);

    final snapshot = await ref.get();
    print(snapshot.value);
    List<Tag> tags = [];
    if (snapshot.exists) {
      Map<dynamic, dynamic> data = snapshot.value as Map<dynamic, dynamic>;
      data.forEach((key, value) {
        tags.add(Tag.fromJson(value));
      });
    }
    return tags;
  }
}
