import 'package:erasmus_helper/models/faq.dart';
import 'package:erasmus_helper/services/faculty_service.dart';
import 'package:erasmus_helper/services/utils_service.dart';
import 'package:firebase_database/firebase_database.dart';

class HelpService {
  static Future<List<FAQModel>> getHelpTips(String facultyId) async {
    List<FAQModel> faqs = [];
    final DataSnapshot snap = await FirebaseDatabase.instance
        .ref("faculties/$facultyId/help_tips/")
        .get();

    if (snap.exists) {
      for (var element in UtilsService.snapToMapOfMap(snap).entries) {
        faqs.add(FAQModel.fromJson(element.key, element.value));
      }
    }

    faqs.sort((a, b) => a.order.compareTo(b.order));
    return faqs;
  }

  static Future<List<FAQModel>> getUserUniHelpTips() async {
    final userUniID = await FacultyService.getUserFacultyId();

    return getHelpTips(userUniID);
  }
}
