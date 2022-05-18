class UserModel {
  String? email, password, fName, lName, facultyOrigin, erasmusFaculty;
  String? description, countryCode, phone, whatsapp, facebook;
  List<String?>? interests = [];
  String uid = "";

  UserModel(
    this.email,
    this.password,
    this.fName,
    this.lName,
    this.facultyOrigin,
    this.erasmusFaculty, {
    this.description,
    this.countryCode,
    this.phone,
    this.whatsapp,
    this.facebook,
    this.interests,
  });

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

  Map<dynamic, dynamic> toJson() => <dynamic, dynamic>{
        "firstName": fName,
        "lastName": lName,
        "faculty_origin_id": facultyOrigin,
        "faculty_arriving_id": erasmusFaculty,
        "description": description,
        "country_code": countryCode,
        "phone": phone,
        "whatsapp": whatsapp,
        "facebook": facebook,
        "interests": interests,
      };

  UserModel.fromJson(Map<dynamic, dynamic> json)
      : fName = json["firstName"],
        lName = json["lastName"],
        facultyOrigin = json["faculty_origin_id"],
        erasmusFaculty = json["faculty_arriving_id"],
        description = json["description"],
        countryCode = json["country_code"],
        phone = json["phone"],
        whatsapp = json["whatsapp"],
        facebook = json["facebook"],
        interests = json["interests"];
}
