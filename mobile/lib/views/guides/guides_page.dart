import 'package:erasmus_helper/views/guides/administration_tab.dart';
import 'package:erasmus_helper/views/guides/university_tab.dart';
import 'package:flutter/material.dart';

// TODO : replace this page with the good content
class GuidesPage extends StatelessWidget {
  const GuidesPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return const DefaultTabController(
      length: 2,
      child: TabBarView(
        children: [AdministrationTab(), UniversityTab()],
      ),
    );
  }
}
