import 'package:erasmus_helper/models/faq.dart';
import 'package:erasmus_helper/services/faq_service.dart';
import 'package:flutter/material.dart';
import 'package:expansion_tile_card/expansion_tile_card.dart';

class UniversityTab extends StatefulWidget {
  const UniversityTab({Key? key}) : super(key: key);

  @override
  State<UniversityTab> createState() => _UniversityTabState();
}

class _UniversityTabState extends State<UniversityTab> {
  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
        future: FAQService.getUserUniFAQs(),
        builder: (context, response) {
          if (response.connectionState == ConnectionState.done) {
            if (response.data != null) {
              return _faqList(context, response.data as List<FAQModel>);
            }
            return const Center(
                child: Text('No available FAQs for this University'));
          }
          return const CircularProgressIndicator();
        });
  }
}

Widget _faqList(BuildContext context, List<FAQModel> faqs) {
  return Padding(
      padding: const EdgeInsets.all(10),
      child: ListView.separated(
          itemCount: faqs.length,
          itemBuilder: (context, index) {
            return ExpansionTileCard(
              initialElevation: 1,
              title: Text(faqs[index].question),
              children: [
                Padding(
                    padding: const EdgeInsets.fromLTRB(10, 10, 10, 15),
                    child: Text(faqs[index].reply))
              ],
            );
          },
          separatorBuilder: (context, index) {
            return const SizedBox(height: 10);
          }));
}
