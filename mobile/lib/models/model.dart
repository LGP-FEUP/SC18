/// Abstract class for all models, currently used to have an automatically generated toString().
/// Would be nice to add automatic json generation in it (if possible)
/// TODO : add default toJson()
abstract class model {
  model();
  Map<String, dynamic> toJson();
  model.fromJson(Map<dynamic, dynamic> json);
  @override
  String toString() {
    return toJson().toString();
  }
}