import 'package:erasmus_helper/models/culture_category.dart';
import 'package:erasmus_helper/services/utils_service.dart';
import 'package:firebase_database/firebase_database.dart';
import 'package:firebase_storage/firebase_storage.dart';

import '../models/culture_entry.dart';

class CultureService {
  static Future<String> getCultureEntryImage(String entryId) async {
    return await FirebaseStorage.instance
        .ref("cultural/$entryId.png")
        .getDownloadURL();
  }

  static Future<List<CultureCategory>> getCultureTags() async {
    List<CultureCategory> entries = [];

    DataSnapshot data = await FirebaseDatabase.instance.ref("categories").get();
    if (data.exists) {
      for (var element in UtilsService.snapToMapOfMap(data).entries) {
        entries.add(CultureCategory.fromJson(element.key, element.value));
      }
    }

    return entries;
  }

  static Future<CultureEntry> getCultureEntry(String entryId) async {
    DataSnapshot data =
        await FirebaseDatabase.instance.ref("culture/$entryId").get();
    var result = UtilsService.snapToMap(data);
    return CultureEntry.fromJson(entryId, result);
  }

  static Future<List<CultureEntry>> getCultureEntriesWithTag(
      String categoryId) async {
    List<CultureEntry> entries = [];
    DataSnapshot snap = await FirebaseDatabase.instance
        .ref("categories/$categoryId/culture")
        .get();
    if (snap.exists) {
      Map<dynamic, dynamic> data = snap.value as Map<dynamic, dynamic>;

      for (var element in data.entries) {
        CultureEntry e = await getCultureEntry(element.key);
        entries.add(e);
      }
    }
    return entries;
  }

  static Future<List<CultureEntry>> getAllCultureEntries() async {
    List<CultureEntry> entries = [];
    DataSnapshot data = await FirebaseDatabase.instance.ref("culture/").get();
    if (data.exists) {
      for (var element in UtilsService.snapToMapOfMap(data).entries) {
        entries.add(CultureEntry.fromJson(element.key, element.value));
      }
    }
    return entries;
  }
}
