class UserModel {
  final String email, password, fName, lName, faculty_origin, erasmus_faculty;
  String uid = "";

  UserModel(this.email, this.password, this.fName, this.lName,
      this.faculty_origin, this.erasmus_faculty);

  Map<String, String> getInfo() {
    return {
      "firstName": fName,
      "lastName": lName,
      "faculty_origin_id": faculty_origin,
      "faculty_arriving_id": erasmus_faculty
    };
  }
}
