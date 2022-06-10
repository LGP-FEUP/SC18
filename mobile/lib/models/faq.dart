import 'package:erasmus_helper/models/model.dart';

class FAQModel extends FirebaseModel {
  final String uid, order, question, reply;

  FAQModel(this.uid, this.order, this.question, this.reply);

  FAQModel.fromJson(this.uid, Map<String, dynamic> json)
      : question = json['question'],
        reply = json['reply'],
        order = json['order'];

  @override
  Map<String, dynamic> toJson() {
    // TODO: implement toJson
    throw UnimplementedError();
  }
}
