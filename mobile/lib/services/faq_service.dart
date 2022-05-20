import 'package:erasmus_helper/models/faq.dart';
import 'package:erasmus_helper/services/faculty_service.dart';
import 'package:erasmus_helper/services/utils_service.dart';
import 'package:firebase_database/firebase_database.dart';

class FAQService {
  static Future<List<FAQModel>> getFAQs(String facultyId) async {
    List<FAQModel> faqs = [];
    final DataSnapshot snap =
        await FirebaseDatabase.instance.ref("faculties/$facultyId/faqs/").get();

    if (snap.exists) {
      for (var element in UtilsService.snapToMapOfMap(snap).entries) {
        faqs.add(FAQModel.fromJson(element.key, element.value));
      }
    }

    faqs.sort((a, b) => a.uid.compareTo(b.uid));
    return faqs;
  }

  static Future<List<FAQModel>> getUserUniFAQs() async {
    final userUniID = await FacultyService.getUserFacultyId();

    return getFAQs(userUniID);
  }
}
