import 'package:erasmus_helper/models/date.dart';
import 'package:erasmus_helper/models/tag.dart';

class UserModel {
  String fName, lName, facultyOrigin, erasmusFaculty;
  late DateModel birthdate;
  String? email, password;
  String? description,
      countryCode,
      phone,
      whatsapp,
      facebook,
      facultyOriginName;
  List<Tag> interests = [];
  String uid = "";
  List<String>? doneTasks;

  UserModel(
      this.email,
      this.password,
      this.fName,
      this.lName,
      this.facultyOrigin,
      this.erasmusFaculty,
      String birthdate,
      this.doneTasks) {
    this.birthdate = DateModel(birthdate);
  }

  UserModel.profile(
      this.fName,
      this.lName,
      this.facultyOrigin,
      this.erasmusFaculty,
      this.description,
      this.countryCode,
      this.phone,
      this.whatsapp,
      this.facebook,
      this.interests);

  UserModel.fromJson(Map<dynamic, dynamic> json)
      : fName = json['firstname'],
        lName = json['lastname'],
        facultyOrigin = json['faculty_origin_id'],
        erasmusFaculty = json['faculty_arriving_id'],
        doneTasks = json['doneTasks'] ?? List.generate(0, (index) => "") {
    final Map<String, dynamic> map =
        (json["date_of_birth"] as Map<dynamic, dynamic>)
            .map((key, value) => MapEntry(key.toString(), value));
    birthdate = DateModel.fromJson(map);
  }

  Map<String, dynamic> toJson() => {
        'id': uid,
        'firstname': fName,
        'lastname': lName,
        'faculty_origin_id': facultyOrigin,
        'faculty_arriving_id': erasmusFaculty,
        "date_of_birth": birthdate.toJson(),
        "validation_level": "1"
      };

  Map<String, dynamic> toProfileJson() => <String, dynamic>{
        "firstname": fName,
        "lastname": lName,
        "faculty_origin_id": facultyOrigin,
        "faculty_arriving_id": erasmusFaculty,
        "description": description,
        "country_code": countryCode,
        "phone": phone,
        "whatsapp": whatsapp,
        "facebook": facebook,
        "interests": _interestsToJson()
      };

  UserModel.fromProfileJson(Map<dynamic, dynamic> json)
      : fName = json["firstname"],
        lName = json["lastname"],
        facultyOrigin = json["faculty_origin_id"],
        erasmusFaculty = json["faculty_arriving_id"],
        description = json["description"],
        countryCode = json["country_code"],
        phone = json["phone"],
        whatsapp = json["whatsapp"],
        facebook = json["facebook"] {
    if (json['interests'] != null) {
      interests = _interestsFromJson(json["interests"]);
    }
  }

  List<Tag> _interestsFromJson(Map<dynamic, dynamic> json) {
    List<Tag> tags = [];
    json.forEach((key, value) {
      if (value) {
        tags.add(Tag.fromString(key));
      }
    });
    return tags;
  }

  Map<String, bool> _interestsToJson() {
    Map<String, bool> map = Map();
    interests.forEach((element) {
      map.addAll(element.toJson());
    });
    return map;
  }
}
