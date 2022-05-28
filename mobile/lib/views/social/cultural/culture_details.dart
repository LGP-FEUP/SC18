import 'package:erasmus_helper/models/culture_entry.dart';
import 'package:erasmus_helper/views/social/cultural/components/culture_details_background.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'components/culture_content.dart';

class CultureDetails extends StatelessWidget {
  final CultureEntry entry;

  const CultureDetails(this.entry, {Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(entry.title),
      ),
      body: Provider<CultureEntry>.value(
        value: entry,
        child: Stack(
          fit: StackFit.expand,
          children: const <Widget>[
            CultureDetailsBackground(),
            CultureContent(),
          ],
        ),
      ),
    );
  }
}
