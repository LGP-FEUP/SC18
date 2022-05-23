import 'package:firebase_database/firebase_database.dart';

class TagService {
  static Future<String> getTagTitle(String tagId) async {
    DataSnapshot data =
        await FirebaseDatabase.instance.ref("interests/$tagId/title").get();
    return data.value.toString();
  }
}
